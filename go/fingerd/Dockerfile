FROM golang:1.19-alpine

WORKDIR /app

COPY go.mod ./
COPY go.sum ./
RUN go mod download

COPY *.go ./

RUN go build -o /fingerd

VOLUME /fingers
EXPOSE 79

CMD [ "/fingerd", "--dir", "/fingers"]
