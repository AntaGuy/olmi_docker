FROM node:10-alpine

RUN apk add --no-cache --virtual .build-deps \
    nano \
	dos2unix \
	&& apk del .build-deps

RUN apk add --update bash && rm -rf /var/cache/apk/*

RUN mkdir /docker
ADD run.sh /docker/run.sh
RUN dos2unix /docker/run.sh \
  && chmod +x /docker/run.sh \
  && chown node:node /docker/run.sh

EXPOSE 3000

CMD ["/docker/run.sh"]
