FROM php:8.3.19-cli-alpine
WORKDIR /usr/src/myApp
COPY src .
EXPOSE 80
CMD [ "php", "-S", "0.0.0.0:80", "-t", "/usr/src/myApp" ]