<pre style="overflow-x: auto"> 
<code style="word-wrap: normal; white-space: pre;">
#!/bin/sh

# Run the PHP script to generate new CSV files.
wget {{ url('/nightly/export') }} > /dev/null 2>&1
sleep 2

# Remove the current Zip file
rm -rf {{ base_path() }}/storage/exports/asm.zip
sleep 2

# Create a new Zip file
cd {{ base_path() }}/storage/exports/
/usr/bin/zip -r asm.zip *
sleep 2

# sFTP the file to Apple
sshpass -f {{ base_path() }}/asm-sftp-password.txt sftp your_username@sftp.apple.com@upload.appleschoolcontent.com:dropbox << !
put {{ base_path() }}/storage/exports/asm.zip
bye
!
</code>
</pre>