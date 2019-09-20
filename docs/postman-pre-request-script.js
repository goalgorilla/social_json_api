// Adapted from: https://gist.github.com/harryi3t/dd5c61451206047db70710ff6174c3c1
// This script will make an {{accessToken}} variable available which can be used
// as oAuth 2.0 Authorization in Postman requests.

let tokenUrl = 'https://localhost/oauth/token';
let clientId = 'consumer-uuid';
let clientSecret = 'secret';
let clientUser = 'username';
let clientPass  = 'password';

let getTokenRequest = {
  method: 'POST',
  url: tokenUrl,
  body: {
    mode: 'formdata',
    formdata: [
      { key: 'grant_type', value: 'password' },
      { key: 'client_id', value: clientId },
      { key: 'client_secret', value: clientSecret },
      { key: 'username', value: clientUser },
      { key: 'password', value: clientPass }
    ]
  }
};

pm.sendRequest(getTokenRequest, (err, response) => {
  let jsonResponse = response.json(),
    newAccessToken = jsonResponse.access_token;

  console.log({ err, jsonResponse, newAccessToken })

  pm.environment.set('accessToken', newAccessToken);
  pm.variables.set('accessToken', newAccessToken);
});
