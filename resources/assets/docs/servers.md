## Routes
**GET** `/api/servers` Returns a listing of all Servers.
**GET** `/api/servers/{server}` Returns data about a Server.
**POST** `/api/servers` Store a new Server. requires dev account.
**DELETE** `/api/servers/{server}` Delete given Server. requires dev account.
**PUT|PATCH** `/api/servers/{server}` Update given Server. requires dev account.
**POST** `/api/servers/{server}/join` Join given Server. authenticated.
**POST** `/api/servers/{server}/leave` Leave given Server. must be authenticated.