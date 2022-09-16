import axios from "axios";

export const apiGoal = axios.create({
  baseURL: 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ9IXDVbwRx3xfvF-42G10RTTOaLij_1jXqxXzRkHRDty9FXt8woRA-o8SoJZYkrFboM9bSKz5odDVH/pub?gid=1829753978&single=true&output=tsv'
}
);
export const apiActions = axios.create({
  baseURL: 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ9IXDVbwRx3xfvF-42G10RTTOaLij_1jXqxXzRkHRDty9FXt8woRA-o8SoJZYkrFboM9bSKz5odDVH/pub?gid=1341425563&single=true&output=tsv'
}
);


export const fetchData = async (setData) => {
  const responseGoal = await apiGoal.get();
  const responseActions = await apiActions.get();
  const goals = tsvToJSON(responseGoal.data);
  const actions = tsvToJSON(responseActions.data);
  goals.map((goal) => {
    goal.acoes = [];
    actions.map((acao) => {
      if (acao.idMeta === goal.id) {
        goal.acoes.push(acao);
      }
      return acao;
    });
    return goal;
  });
  setData(goals);
};

export const fetchSelected = async (setSelected, id) => {
  const responseGoal = await apiGoal.get();
  const responseActions = await apiActions.get();
  const goals = tsvToJSON(responseGoal.data);
  const actions = tsvToJSON(responseActions.data);
  var selected = null;
  goals.map((goal) => {
    goal.acoes = [];
    actions.map((acao) => {
      if (acao.idMeta === goal.id) {
        goal.acoes.push(acao);
      }
      return acao;
    });
    return goal;
  });
  goals.map((goal) => {
    if (id === goal.id) {
      selected = goal;
    }
    return goal;
  });
  setSelected(selected);
};

function tsvToJSON(csv) {
  const lines = csv.split('\r\n');
  const result = [];
  const headers = lines[0].split('\t');
  for (let i = 1; i < lines.length; i++) {
    if (!lines[i]) {
      continue;
    }
    const obj = {};
    const currentline = lines[i].split('\t');
    for (let j = 0; j < headers.length; j++) {
      obj[headers[j]] = currentline[j];
    }
    result.push(obj);
  }
  return result;
}
