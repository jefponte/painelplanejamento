import axios from 'axios';

export const apiData = axios.create({
  baseURL: 'https://sheetdb.io/api/v1/bj9pvb123v2kw',
});

export const getData = async (setData) => {
  const response = await apiData.get();
  setData(response.data);
};