FROM python:3.13
WORKDIR /app
RUN zypper refresh && zypper install -y \
    mariadb \
    mariadb-client \
    && zypper clean --all
COPY pythonreq.txt .
RUN pip install --no-cache-dir -r pythonreq.txt
COPY . .
EXPOSE 8000
CMD ["uvicorn", "main:app", "--host", "0.0.0.0", "--port", "8000"]