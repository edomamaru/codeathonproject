import os
import re
import urllib.parse
import eyed3

def expand(filename):
    """Expand numbers in the filename to 4 digits for sorting."""
    parts = []
    for part in re.split('([0-9]+)', filename):
        if part.isdigit():
            parts.append(part.zfill(4))
        else:
            parts.append(part)
    return ''.join(parts)

def generate_links(directory, html_file_path):
    os.chdir(directory)
    files = [f for f in os.listdir('.') if f.startswith('Luke') and f.endswith('.mp3')]
    files = sorted(files, key=expand)

    links = []
    for filename in files:
        audiofile = eyed3.load(filename)
        title = audiofile.tag.title if audiofile.tag.title else "Unknown Title"
        encoded_filename = urllib.parse.quote(filename)  # URL-encode the filename
        links.append(f'<a href="{encoded_filename}">{title}</a><br />\n')

    # Write links to the HTML file
    with open(html_file_path, 'r+', encoding='utf-8') as html_file:
        content = html_file.read()
        position = content.find('<b>hello</b>') + len('<b>hello</b>\n')
        new_content = content[:position] + ''.join(links) + content[position:]
        html_file.seek(0)
        html_file.write(new_content)
        html_file.truncate()

# Specify the directory containing the MP3 files
directory = "C:\Users\15714\Desktop\codathon\fsm-team-escp-komorebi.mp3"
# Specify the path to your HTML file
html_file_path = "path/to/your/index.html"
generate_links(directory, html_file_path)
