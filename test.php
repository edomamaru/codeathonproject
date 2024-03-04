<?php
// Include the getID3 library for extracting MP3 metadata.
// Ensure you have downloaded this library and provide the correct path to the getID3.php file.
require_once 
'/Users/souadyakubu/Desktop/mp3/getID3-master/getid3/getid3.php';
// Set the directory where your MP3 files are located.
$dir = "/Users/souadyakubu/Desktop/mp3/blank-audio";
echo "Scanning directory: $dir\n";

$array = array(
        0=>  "Genesis",
        1=>  "Exodus",
        2=>  "Leviticus",
        3=>  "Numbers",
        4=>  "Deuteronomy",
        5=>  "Joshua",
        6=>  "Judges",
        7=>  "Ruth",
        8=>  "1 Samuel",
        9=>  "2 Samuel",
        10=> "1 Kings",
        11=> "2 Kings",
        12=> "1 Chronicles",
        13=> "2 Chronicles",
        14=> "Ezra",
        15=> "Nehemiah",
        16=> "Esther",
        17=> "Job",
        18=> "Psalms",
        19=> "Proverbs",
        20=> "Ecclesiastes",
        21=> "Song of Solomon",
        22=> "Isaiah",
        23=> "Jeremiah",
        24=> "Lamentations",
        25=> "Ezekiel",
        26=> "Daniel",
        27=> "Hosea",
        28=> "Joel",
        29=> "Amos",
        30=> "Obadiah",
        31=> "Jonah",
        32=> "Micah",
        33=> "Nahum",
        34=> "Habakkuk",
        35=> "Zephaniah",
        36=> "Haggai",
        37=> "Zechariah",
        38=> "Malachi",
        39=> "Matthew",
        40=> "Mark",
        41=> "Luke",
        42=> "John",
        43=> "Acts",
        44=> "Romans",
        45=> "1 Corinthians",
        46=> "2 Corinthians",
        47=> "Galatians",
        48=> "Ephesians",
        49=> "Philippians",
        50=> "Colossians",
        51=> "1 Thessalonians",
        52=> "2 Thessalonians",
        53=> "1 Timothy",
        54=> "2 Timothy",
        55=> "Titus",
        56=> "Philemon",
        57=> "Hebrews",
        58=> "James",
        59=> "1 Peter",
        60=> "2 Peter",
        61=> "1 John",
        62=> "2 John",
        63=> "3 John",
        64=> "Jude",
        65=> "Revelation",
        );

for( $i = 0; $i < 66; $i++ ) {
    // Use the glob function to find all MP3 files starting with 'Luke' in the specified directory.
    // This pattern can be adjusted to match different or more files.
    $files = glob($dir . $array[$i] . "*.mp3");
    echo "Found " . count($files) ." files matching the pattern.\n";
    // Sort the files array using a custom sort function to handle numeric parts correctly.
    // This ensures that files are sorted in a natural order, for example, Luke2 comes before Luke10.
    usort($files,function ($a,$b) {
    return strnatcmp(expand($a),expand($b));
    });
    // Iterate over each file found in the directory.
    foreach ($files as$filename) {
    // Create a new getID3 object to analyze the file.
    $getID3 = new getID3;
    // Analyze the file and store the resulting array in $fileInfo.
    $fileInfo = $getID3->analyze($filename);
    // Attempt to retrieve the title from the ID3v2 tag, falling back to ID3v1 if necessary.
    // If neither is present, default the title to "Unknown Title".
    if (isset($fileInfo['tags']['id3v2']['title'][0])){
    $title = $fileInfo['tags']['id3v2']['title'][0];
    } elseif (isset($fileInfo['tags']['id3v1']['title'][0])){
    $title = 
    $fileInfo['tags']['id3v1']['title'][0];
    } else {
    $title = "Unknown Title";
    }
    echo "Title found: " . $title . "\n";
    // Encode spaces in filenames to %20 for use in URLs.
    // Use basename to remove the directory path, leaving just the filename.
    $encodedFilename = str_replace(' ', '%20', basename($filename));
    // Output the HTML link for the file, using htmlspecialchars to avoid XSS vulnerabilities.
    // Inline styling is applied to ensure the text fits the requirements (Arial, Verdana, 16px font size).
    //echo "<a href=\"$encodedFilename\" style=\"font-family: Arial, Verdana; font-size: 16px;\">" . htmlspecialchars($title) . "</a><br />\n";
    echo "HTML link: <a href=\"$encodedFilename\" style=\"font-family: Arial, Verdana; font-size: 16px;\">" .htmlspecialchars($title) ."</a><br />\n";
    }
    // Define a function to 'expand' numeric parts of filenames for natural sorting.
    // This function replaces all numeric parts with a zero-padded string of equal value, ensuring proper comparison.
    function 
    expand($filename){
    return preg_replace_callback('/\d+/',function ($matches) {// Pad each number to 4 digits, adjusting as necessary for your specific file naming conventions.
    return sprintf('%04d', $matches[0]); }, $filename);
    }
}

?>