# Syncemap

## Introduction

Syncemap is a library for synchronize and copy all the emails and content (folders, attachments...) to another living email.
The need of change the domain and host of a corporative email to another create this library.

## Aplications

The initial aplications of this code is to copy all the contents from a email to another. 

You can synchronize two emails or more with differents domains or differents names.

Or use one email as a backup for anothers.

## How does it work?

Simple, Syncemap works with php and with the core library of IMAP of php. With the credentials with an email and the library, Syncemap make a petition to obtain all the structure of the first email. Then with the credentials of the second, syncemap replicate that structure. 
With the structure created Syncemap synchronize both email in one direction, the first to the second.

The methodology of that sincrhonization is simple, the first email send all of its emails to the second email. But Syncemap send it without changing the remitent of the emails so, you never see the first email as a remitent. All the data of the emails remain exactly the same **except the date of that email** (because u receive it when Syncemap did his job).

## How to use it?

The function have six variables :
<code>
  syncemap($userOut, $passOut, $userIn, $passIn, $domOut, $domIn)
</code>

All synchronization is done in one direction, so you need the first email (to copy it), his password (to access) and the server of email (to access).
The same for the second email so:
<code>
  syncemap("email for copy", "pass of that email", "email to copy all", "pass of the second email", "email server for the first email", "email for the second email")
</code>


## Performance
Actually the perfomance is not good, 100 emails with some attachments have a waiting time of 50 seconds more or less. The code has to travel for all the folders and make differents connections for each folder, and then send directly, all the emails.

You can boost it if your server dont have a cap for receive or send multiple emails (a large amount of them).

## Possible Errors

### Syncemap jobe is done and i dont see all the emails.
  It is normal (for how IMAP works) that you didnt see all the synchro in your client the time Syncemap did his job. IMAP synchronize the server folder in your client with all the email each time you open it. So its normal that you cant visualize all the email in the client instantly but all the emails are sent.
  
  
