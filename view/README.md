## City coordinates [React Simple Maps]

react-simple-maps package requires set coordinates for points. They are latitude and longitude.

Get data from google and convert to format is as pattern below:

```
N === + (positive) latitude
S === - (negative) latitude

E === + (positive) longitude
W === - (negative) longitude

[ longitude, latitude ]
[ E/W, N/S ]

```

For example

```
15.6014° S, 56.0979° W == [ -56.0979, -15.6014 ]
52.2297° N, 21.0122° E == [ 21.0122, 52.2297 ]
```