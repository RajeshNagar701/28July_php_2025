


<?php
/*
File handling is an important part of any web application. 
You often need to open and process a file for different tasks.


PHP Manipulating Files
PHP has several functions for creating, reading, uploading, and editing files.

1) PHP Open File - fopen()  // fopen("webdictionary.txt", "r")  // r / w / r+ / w+ / a / a+

Modes	Description
r	Open a file for read only. File pointer starts at the beginning of the file
w	Open a file for write only. Erases the contents of the file or creates a new file if it doesn't exist. File pointer starts at the beginning of the file
a	Open a file for write only. The existing data in file is preserved. File pointer starts at the end of the file. Creates a new file if the file doesn't exist
x	Creates a new file for write only. Returns FALSE and an error if file already exists
r+	Open a file for read/write. File pointer starts at the beginning of the file
w+	Open a file for read/write. Erases the contents of the file or creates a new file if it doesn't exist. File pointer starts at the beginning of the file
a+	Open a file for read/write. The existing data in file is preserved. File pointer starts at the end of the file. Creates a new file if the file doesn't exist
x+	Creates a new file for read/write. Returns FALSE and an error if file already exists



2) PHP readfile() Function
The readfile() function reads a file and writes it to the output buffer.

Assume we have a text file called "webdictionary.txt", stored on the server, that looks like this:

or

The fread() function reads from an open file.
fread($myfile,filesize("webdictionary.txt"));

or

PHP Read Single Line - fgets() 
read a single character from a file. The fgetc() 

PHP Check End-Of-File - feof()

$myfile = fopen("webdictionary.txt", "r")
while(!feof($myfile)) {
  echo fgets($myfile) . "<br>";
}
fclose($myfile);


3) fwrite();

fwrite($file,"Helllo i am file handeling"); //write

4) The fclose() function is used to close an open file.
*/

// file Handeling create / open / write / close

/*
$file=fopen("users.txt","w"); // if file exist then open or not then create
fwrite($file,"Helllo i am file handeling"); //write
fclose($file);  // close
*/


// file Handeling read

$file = fopen('users.txt','r');
echo fread($file,filesize('users.txt'));
fclose($file);

?>