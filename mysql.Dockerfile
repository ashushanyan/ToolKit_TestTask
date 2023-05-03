FROM mysql:8.0

COPY ./mysql/custom.cnf /etc/mysql/conf.d/
