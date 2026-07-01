import os, re, json

controllers_dir = 'app/Http/Controllers'
strings = set()
with_pattern = re.compile(r"->with\(\s*['\"](?:success|error|info|warning)['\"]\s*,\s*['\"]([^'\"]+)['\"]\s*\)")

def replace_with(match):
    text = match.group(1)
    strings.add(text)
    return match.group(0).replace(f"'{text}'", f"__('{text}')").replace(f'"{text}"', f"__('{text}')")

for root, _, files in os.walk(controllers_dir):
    for file in files:
        if file.endswith('.php'):
            path = os.path.join(root, file)
            with open(path, 'r', encoding='utf-8') as f:
                content = f.read()
            new_content = with_pattern.sub(replace_with, content)
            if new_content != content:
                with open(path, 'w', encoding='utf-8') as f:
                    f.write(new_content)

print(f'Patched controllers. Found {len(strings)} unique messages.')

if os.path.exists('lang/en.json'):
    with open('lang/en.json', 'r') as f:
        en = json.load(f)
    for s in strings:
        en[s] = s
    with open('lang/en.json', 'w') as f:
        json.dump(en, f, indent=4)

if os.path.exists('lang/sw.json'):
    with open('lang/sw.json', 'r') as f:
        sw = json.load(f)
    for s in strings:
        if s not in sw:
            sw[s] = s
    with open('lang/sw.json', 'w') as f:
        json.dump(sw, f, indent=4)
