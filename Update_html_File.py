import json

in_file = open("in_file.json") # open json file
out_file = open("out_file.html") # open html file

data = json.loads(in_file.read()) # data is json object
# iterate through the json list
for i in data['json obj name']:
    py_dict = i
    print(i)
    
    output = '"<a href="' + py_dict["jsonLink"] + '">' + py_dict["jsonTitle"] + "</a></p>"
    
    # Adding input data to the HTML file
    out_file.write(output)

# Saving the data into the HTML file
in_file.close()
out_file.close()
