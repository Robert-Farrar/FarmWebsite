FROM opensuse/leap:15.6
WORKDIR /app
RUN zypper refresh && zypper install -y \
    python311 \
    python311-pip \
    mariadb \
    mariadb-client \
    && zypper clean --all
RUN update-alternatives --install /usr/bin/python python /usr/bin/python3 1 && \
python --version
COPY . .
COPY script.sql /app/script.sql
RUN pip3 install --no-cache-dir -r requirements.txt
RUN mkdir -p /run/mysqld && chown mysql:mysql /run/mysqld
EXPOSE 8000
CMD ["/bin/sh", "-c", " \
    mariadb-install-db --user=mysql --datadir=/var/lib/mysql && \
    /usr/bin/mysqld_safe --datadir=/var/lib/mysql --socket=/var/run/mysql/mysql.sock & \
    sleep 10 && \
    mariadb -u root < /app/script.sql && \
    exec uvicorn main:app --host 0.0.0.0 --port 8000"]