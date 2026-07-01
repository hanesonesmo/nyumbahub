import os, re, json

views_dir = "resources/views"
strings = set()

# Regex to capture text between > and <
text_pattern = re.compile(r">([^<\{\}]+)<")
placeholder_pattern = re.compile(r"placeholder=[\"']([^\"']+)[\"']")

for root, _, files in os.walk(views_dir):
    for file in files:
        if file.endswith(".blade.php"):
            path = os.path.join(root, file)
            with open(path, "r", encoding="utf-8") as f:
                content = f.read()
                
                # Find texts
                for match in text_pattern.findall(content):
                    text = match.strip()
                    if text and not text.isspace() and not text.startswith("@") and len(text) > 1:
                        # Ignore numbers or purely non-alphabetical
                        if re.search(r"[a-zA-Z]", text):
                            strings.add(text)
                            
                # Find placeholders
                for match in placeholder_pattern.findall(content):
                    text = match.strip()
                    if text and not text.isspace():
                        strings.add(text)

print(f"Found {len(strings)} unique strings.")

# Write to a temporary JSON file to inspect
with open("extracted_strings.json", "w", encoding="utf-8") as f:
    json.dump(list(strings), f, indent=4)
