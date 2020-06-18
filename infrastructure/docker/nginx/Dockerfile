FROM node:14.2-alpine as node
FROM nginx:1.18-alpine
SHELL ["/bin/ash", "-oeux", "pipefail", "-c"]

ENV TZ=UTC

RUN apk update && \
  apk add --update --no-cache --virtual=.build-dependencies g++ && \
  cp /etc/nginx/nginx.conf /etc/nginx/nginx.conf_bkup && \
  adduser -u 82 -D -S -G www-data www-data
#addgroup -g 82 -S www-data \
#www-data の groupはすでに存在 nginx.confのlisten.owner = www-dataに合わせる
#memo: System-user, Dont-create-password, Group addUserは最後 user to groupを指定

COPY --from=node /usr/local/bin /usr/local/bin
COPY --from=node /opt /opt
COPY ./default.conf /etc/nginx/conf.d/default.conf
COPY ./nginx.conf /etc/nginx/nginx.conf

WORKDIR /work/backend
