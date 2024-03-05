# import subprocess 
# import json

# # Path to the PHP script
# php_script_path = '/Users/souadyakubu/Desktop/mp3/mp3.php'

# # Execute the PHP script and capture its output
# result = subprocess.run(['php', php_script_path],
#                         capture_output=True, text=True)

# # Check if the execution was successful
# if result.returncode == 0:
#     # Parse the JSON output from the PHP script
#     data = json.loads(result.stdout)

#     # Start building the HTML content
#     html_content = """
    
# <!DOCTYPE html>
# <html lang="en">
# <head>
#     <meta charset="UTF-8">
#     <title>MP3 Links</title>
# </head>
# <bod
#     <div id="results">
# """

#     # Add links for each item in the data
#     for item in data:
#         html_content += f"""        <a href="{item['link']}" style="font-family: Arial, Verdana; font-size: 16px;">{item['title']}</a><br>\n"""

#     # Close the HTML content
#     html_content += """
#     </div>
# </body>
# </html>
# """

#     # Write the HTML content to a file
#     with open('mp3_links.html', 'w') as file:
#         file.write(html_content)
#     print("HTML file generated successfully.")
# else:
#     print("Error executing PHP script:", result.stderr)








import subprocess 
import json

# Path to the PHP script
php_script_path = '/Users/souadyakubu/Desktop/mp3/mp3.php'

# Execute the PHP script and capture its output
result = subprocess.run(['php', php_script_path], capture_output=True, text=True)

# Check if the execution was successful
if result.returncode == 0:
    # Parse the JSON output from the PHP script
    data = json.loads(result.stdout)

    # Start building the HTML content
    html_content = ""

    # Add links for each item in the data
    for item in data:
        html_content += '<a href="' + item['link'] + '"style="font-family: Arial, Verdana; font-size: 16px;">' + item['title'] + '</a><br>\n'

    # Write the HTML content to a file
    with open('mp3_links.html', 'w') as file:
        file.write(html_content)
        print("HTML file generated successfully.")

else:
    print("Error executing PHP script:", result.stderr)