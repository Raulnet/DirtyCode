#!/bin/sh

uid=$(stat -c %u /srv)
gid=$(stat -c %g /srv)

if [ $uid == 0 ] && [ $gid == 0 ]; then
    if [ $# -eq 0 ]; then
        sleep 9999d
    else
        exec "$@"
    fi
fi

sed -i -r "s/__node:x:1000:1000:Linux/__node:x:100:100:Linux/g" /etc/passwd

sed -i -r "s/__node:x:\d+:\d+:/__node:x:$uid:$gid:/g" /etc/passwd
sed -i -r "s/__node:x:\d+:/__node:x:$gid:/g" /etc/group
chown __node /home

if [ $# -eq 0 ]; then
    sleep 9999d
else
    exec su-exec __node "$@"
fi
