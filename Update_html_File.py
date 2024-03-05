import json
import subprocess
# directory = input("Please input the file directory containing new mp3 files: ")

# use subprocess to run PHP file with directory as input
# PHP file updates json file with new mp3 data
subprocess.run(["mp3.php"], shell=True)

json_file = open("mp3_obj.json", 'r') # open json file
html_file = open("writeTo.html", 'w') # open html file
output = ''

json_data = json.loads(json_file.read()) # json_data is json object
# iterate through the json object
for i in json_data['mp3_data']:
    # 'i' is a python dictionary containing "mp3_link" and "mp3_title" as keys,
    # both containing strings for the mp3 link and title respectively
    # use i to get the strings to create the html output
    output += '<a href="' + i["mp3_link"] + '">' + i["mp3_title"] + "</a></p>\n"

# Write to the HTML file
html_file.write(output)

# Saving the data into the HTML file
json_file.close()
html_file.close()
