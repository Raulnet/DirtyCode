FROM node:12.4.0-alpine

ENTRYPOINT ["entrypoint"]

ENV SU_EXEC_VERSION=0.2-r0

RUN apk add --no-cache su-exec=${SU_EXEC_VERSION} && \
    addgroup __node && \
    adduser -D -h /home -s /bin/sh -G __node __node

COPY entrypoint.sh /entrypoint

WORKDIR /srv/


