const request = async (
  url,
  { onPending, onSuccess, onError, onSettled, ...fetchOpts },
) => {
  onPending && onPending();
  return fetch(url, fetchOpts)
    .then(async (res) => {
      const data = await res.json();
      onSuccess && onSuccess(data);
      console.log(data);
      return data;
    })
    .catch((e) => {
      console.log(e);
      onError && onError(e);
    })
    .finally(() => {
      console.log("settled");
      onSettled && onSettled();
    });
};

const postRequest = async (url, { method, headers, body, json, ...reqOpts }) =>
  await request(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      ...headers,
    },
    body: JSON.stringify(json),
    ...reqOpts,
  });

const redirect = (url) => {
  window.location.replace(url);
};
