import json
import subprocess
# directory = input("Please input the file directory containing new mp3 files: ")

# use subprocess to run PHP file with directory as input
# PHP file updates json file with new mp3 data

# json_file = open("mp3_obj.json", 'r') # open json file
html_file = open("html_output.html", 'w') # open html file
output = ''

# get the json object from the php script by running the php script using subprocess and capturing the output as json_obj
json_obj = subprocess.run(["mp3.php"], shell=True, capture_output = True, text = True)
json_data = json.loads(json_obj.stdout) # json_data is json object

# iterate through the json object
for i in json_data['results']:
    # 'i' is a python dictionary containing "mp3_link" and "mp3_title" as keys,
    # both containing strings for the mp3 link and title respectively
    # use i to get the strings to create the html output
    output += '<a href="' + i["link"] + '">' + i["title"] + "</a></p>\n"

# Write to the HTML file
html_file.write(output)

# Saving the data into the HTML file
# json_file.close()
html_file.close()

