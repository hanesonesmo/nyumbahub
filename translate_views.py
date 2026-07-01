import os, re, json

views_dir = "resources/views"
strings = set()

# Regex to capture text between > and <
text_pattern = re.compile(r">([^<]+)<")

def replace_texts(match):
    original = match.group(1)
    stripped = original.strip()
    
    # Skip empty, Blade directives, variables, or purely non-alphabetical
    if not stripped or stripped.startswith('@') or not re.search(r'[a-zA-Z]', stripped):
        return match.group(0)
        
    # Skip if it contains blade variable bindings
    if '{' in original or '}' in original:
        return match.group(0)
        
    # Add to our dictionary
    strings.add(stripped)
    
    # Replace preserving the exact whitespace
    return match.group(0).replace(stripped, f"{{{{ __('{stripped.replace('\'', '\\\'')}') }}}}")

for root, _, files in os.walk(views_dir):
    for file in files:
        if file.endswith(".blade.php"):
            path = os.path.join(root, file)
            with open(path, "r", encoding="utf-8") as f:
                content = f.read()
                
            # Replace text nodes
            new_content = text_pattern.sub(replace_texts, content)
            
            # Replace placeholders
            def replace_placeholders(match):
                attr_name = match.group(1)
                quote = match.group(2)
                text = match.group(3)
                
                stripped = text.strip()
                if not stripped or '{' in text or '}' in text or not re.search(r'[a-zA-Z]', stripped):
                    return match.group(0)
                
                strings.add(stripped)
                # {{ __('text') }} inside an attribute
                return f"{attr_name}={quote}{{{{ __('{stripped.replace('\'', '\\\'')}') }}}}{quote}"

            placeholder_pattern = re.compile(r"(placeholder|title|alt)=([\"'])(.*?)([\"'])")
            new_content = placeholder_pattern.sub(replace_placeholders, new_content)
            
            if new_content != content:
                with open(path, "w", encoding="utf-8") as f:
                    f.write(new_content)

print(f"Patched views. Found {len(strings)} unique strings.")

# Load existing translations or create new
en_translations = {}
for s in strings:
    en_translations[s] = s

with open('lang/en.json', 'w', encoding="utf-8") as f:
    json.dump(en_translations, f, indent=4, ensure_ascii=False)

# For sw.json, we will initialize it if it doesn't exist, or just append missing ones.
sw_translations = {}
if os.path.exists('lang/sw.json'):
    with open('lang/sw.json', 'r', encoding="utf-8") as f:
        try:
            sw_translations = json.load(f)
        except:
            pass

for s in strings:
    if s not in sw_translations:
        sw_translations[s] = s # Default to english, we will translate them later

with open('lang/sw.json', 'w', encoding="utf-8") as f:
    json.dump(sw_translations, f, indent=4, ensure_ascii=False)
