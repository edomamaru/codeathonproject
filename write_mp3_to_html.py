from mutagen.mp3 import MP3
from mutagen.easyid3 import EasyID3
from mutagen.flac import FLAC
import mutagen.id3
from mutagen.id3 import ID3, TIT2, TIT3, TALB, TPE1, TRCK, TYER

import os
# import glob
# import numpy as np

# Input directory of mp3 files
directory = input("Input a Directory Containing New MP3 Files: ")
# Create list of every mp3 file name in directory
mp3_list = os.listdir(directory)
# Open html file/define html content to write to file
html_file = open("mp3_links.html", "w")
html_content = ''

# For each file in the directory
for i in mp3_list:
    # Set 'file' as path to file (directory/fileName) -> gives path to mp3 file
    file = directory + "/" + i
    # Use mutagen to get mp3 file ID3 metadata
    # mutagen.File creates mutagen.easyid3.EasyID3 object (see link)
    # https://mutagen.readthedocs.io/en/latest/api/id3.html#mutagen.easyid3.EasyID3
    meta = mutagen.File(file, easy=True)
    
    # DO NOT UNCOMMENT #
    # This code resets the tag to default so we could test the code, if run it will reset the tag of all the mp3 files in the directory
    # meta.tags['compilation'] = ['0'] # reset 'compilation' tag for testing 
    # USED FOR TESTING #
    
    # Check if 'compilation' tag len is != 2 or if 'compilation'[1] is not 'read by script', if true, add to html_content and update tag
    if ((len(meta.tags['compilation']) != 2) or (meta.tags['compilation'][1] != 'read by script')):
        # Update html content string
        html_content += '<a href="' + file + '"style="font-family: Arial, Verdana; font-size: 16px;">' + meta.tags['title'][0] + '</a><br>\n'
        
        # update 'compilation' tag to ['0', 'read by script']
        temp = meta.tags['compilation']
        temp.append('read by script')
        meta.tags['compilation'] = temp
        meta.tags.save(file)
        
# Write html_content to html_file and close file
html_file.write(html_content)
html_file.close()
