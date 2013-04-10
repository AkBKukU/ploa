Error code guide
================

Here is and example code
PL01P001

[PL] The first two characters represent that it is  a ploa error. 

[01] The next two numbers representthe action type. Here are the actions and their codes:

- 01: Write
- 02: Read
- 03: Modify
- 04: Delete

[P] The next character identifies whether is was a post(P) or user(U).

[001] The next three numbers identify a particular peice  of code. They will show where the error happened. Here are the identities:

- 001: Adding a new post - class.LoadPosts.php
- 002: Updating a post - class.LoadPosts.php
- 003: Deleting a post - class.LoadPosts.php
- 004: Deleting a user - class.LoadPosts.php
- 005: Updating a user - class.LoadPosts.php
