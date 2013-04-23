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

[P] The next character identifies whether is was a post(P), user(U), settings(C), or raw SQL(S).

[001] The next three numbers identify a particular peice  of code. They will show where the error happened. Here are the identities:

- 001: Adding a new post
- 002: Updating a post
- 003: Deleting a post
- 004: Deleting a user
- 005: Updating a user
- 006: Adding userid column
- 007: Adding displaydate column
- 008: Adding allowcomments column
- 009: Failed to update user Settings
- 010: User already exists
- 011: Failed to add user
