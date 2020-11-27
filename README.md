# ping

Check if your service is online.

Demo https://ping.dakovdev.com

## Guidelines

### RESTful URLs

- Get data:

  - GET https://ping.dakovdev.com/api/v1/ping?host=ip-or-hostname

- Response:

```json
{
  "host": "google.com",
  "online": true
}
```

```json
{
  "host": "google123123.com",
  "online": false
}
```
