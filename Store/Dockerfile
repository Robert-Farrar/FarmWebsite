FROM opensuse/leap:15.6
WORKDIR /app
RUN zypper refresh && zypper install -y \
    python3 \
    python3-pip \
    mariadb \
    mariadb-client \
    && zypper clean --all

COPY . .
RUN pip3 install --no-cache-dir -r pythonreq.txt
RUN mkdir -p /run/mysqld && chown mysql:mysql /run/mysqld
EXPOSE 8003
CMD ["/bin/sh", "-c", " \
    mariadb-install-db --user=mysql --datadir=/var/lib/mysql && \
    /usr/bin/mysqld_safe --datadir=/var/lib/mysql --socket=/var/run/mysql/mysql.sock & \
    sleep 10 && \
    mariadb -u root < /app/script2.sql && \
    exec uvicorn main:app --host 0.0.0.0 --port 8003"]