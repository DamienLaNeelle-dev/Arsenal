const axios = require("axios");

const options = {
  method: "GET",
  url: "https://arsenal-fc.p.rapidapi.com/news",
  headers: {
    "X-RapidAPI-Key": "e7ea488d93msh42a6013a823f7e1p1c736cjsneacc176a1b5b",
    "X-RapidAPI-Host": "arsenal-fc.p.rapidapi.com",
  },
};

async function fetchNews() {
  try {
    const response = await axios.request(options);
    return response.data;
  } catch (error) {
    console.error(error);
    return null;
  }
}

export default fetchNews;
