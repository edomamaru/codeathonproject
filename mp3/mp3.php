<?php
// Include the getID3 library for extracting MP3 metadata.
// Ensure you have downloaded this library and provide the correct path to the getID3.php file.
require_once '/Users/souadyakubu/Desktop/mp3/getID3-master/getid3/getid3.php'; //used to embed PHP code from getid3 file

// Set the directory where your MP3 files are located.
$dir = "/Users/souadyakubu/Desktop/mp3/blank-audio";
//echo "Scanning directory: $dir\n";
// Use the glob function to find all MP3 files starting with 'Luke' in the specified directory.
// This pattern can be adjusted to match different or more files.

// $array = array("Genesis","Exodus", "Leviticus","Numbers","Deuteronomy", "Joshua", "Judges", "Ruth", "1 Samuel", "2 Samuel","1 Kings", "2 Kings",
// "1 Chronicles", "2 Chronicles","Ezra","Nehemiah","Esther","Job","Psalms","Proverbs","Ecclesiastes", "Song of Solomon", "Isaiah",
// "Jeremiah","Lamentations", "Ezekiel", "Daniel","Hosea","Joel","Luke"
// );


$files = glob($dir . "/1-hour*.mp3");
//echo "Found " . count($files) . " files matching the pattern.\n";
// Sort the files array using a custom sort function to handle numeric parts correctly.
// This ensures that files are sorted in a natural order, for example, Luke2 comes before Luke10.
usort($files, function ($a, $b) {
    return strnatcmp(expand($a), expand($b));
});

$results = [];
// Iterate over each file found in the directory.
foreach ($files as $filename) {
    // Create a new getID3 object to analyze the file.
    $getID3 = new getID3;
    // Analyze the file and store the resulting array in $fileInfo.
    $fileInfo = $getID3->analyze($filename);// Creating an instance of this class initializes the getID3 engine, preparing it to analyze files.

    // Attempt to retrieve the title from the ID3v2 tag, falling back to ID3v1 if necessary.
    // If neither is present, default the title to "Unknown Title".
    if (isset($fileInfo['tags']['id3v2']['title'][0])) {//This line checks if the MP3 file has an ID3v2 tag that includes a title. 
        $title = $fileInfo['tags']['id3v2']['title'][0];
    } elseif (isset($fileInfo['tags']['id3v1']['title'][0])) {
        $title = $fileInfo['tags']['id3v1']['title'][0];//If the MP3 file does not have an ID3v2 title tag, the script then checks for an ID3v1 title tag
    } else {
        $title = "Unknown Title";
    }
    //echo "Title found: " . $title . "\n";
    // Encode spaces in filenames to %20 for use in URLs.
    // Use basename to remove the directory path, leaving just the filename.
    $encodedFilename = str_replace(' ', '%20', basename($filename));
    $results[] = [
        'title' => $title,
        'link' => $encodedFilename
    ];

    // Output the HTML link for the file, using htmlspecialchars to avoid XSS vulnerabilities.
    // Inline styling is applied to ensure the text fits the requirements (Arial, Verdana, 16px font size).

    //echo "<a href=\"$encodedFilename\" style=\"font-family: Arial, Verdana; font-size: 16px;\">" . htmlspecialchars($title) . "</a><br />\n";
    //echo "HTML link: <a href=\"$encodedFilename\" style=\"font-family: Arial, Verdana; font-size: 16px;\">" . htmlspecialchars($title) . "</a><br />\n";
}



// Define a function to 'expand' numeric parts of filenames for natural sorting.
// This function replaces all numeric parts with a zero-padded string of equal value, ensuring proper comparison.
header('Content-Type: application/json');
echo json_encode($results);
function expand($filename)
{
    return preg_replace_callback('/\d+/', function ($matches) {
        // Pad each number to 4 digits, adjusting as necessary for your specific file naming conventions.
        return sprintf('%04d', $matches[0]);
    }, $filename);
}
?>