# Application
The Config File Parser is a PHP Script that iterates through mutiple text files and parses text in between values supplied by the user. The script was intended as a way to extract specific pieces of data from auto-generated device configuration 
files of unpredictable content and length.

# Usage
Use $PriStart, $SecStart and $Stop to specify the limiter text. The limiters are the text on right and left (or top and bottom depending on how you think about it) of the text that you wish to parse. For example, if a text file contains "John and 
his dog like to take walks" and the text I wish to parse is "dog", the primary limiter ($PriStart) would be "John and his " and the stop/ending limiter ($Stop) would be " like to take walks). Notice the " " <SPACE> character, the limiters must 
include EVERY character upto the first and last character of the parsed text. 

# Notes
The purpose of this script will be expanded and functions further developed in the future, which is why I chose to write this script in OO notation rather than a simple procedural script. The OO overhead is there for a reason ;).

# Version History
- 1.0 
  - *Base function*
- 1.5 
  - *Code refactored from procedural into OOP*
  - *Commenting added*
  - *README.md file further developed*
