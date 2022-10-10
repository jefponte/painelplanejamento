import axios from "axios";
import LinearProgressWithLabel from "../components/LinearProgressWithLabel";


export const columns = [
  { field: 'id', headerName: "Nº", width: 25 },
  { field: 'classificacaoObjetivo', headerName: "Classificação do Objetivo", width: 200 },
  { field: 'objetivo', headerName: "Objetivo", width: 200 },
  { field: 'classificacaoIndicador', headerName: "Classificação do Indicador", width: 200 },
  { field: 'categoriaIndicador', headerName: "Categoria do Indicador" },
  { field: 'tipoIndicador', headerName: "Tipo de Indicador" },
  { field: 'descricaoIndicador', headerName: "Descrição do Indicador", width: 250 },
  { field: 'descricao', headerName: "Descrição da Meta", width: 250 },
  {
    field: 'percentualBarr', headerName: "Progresso", width: 250,
    renderCell: (cellValues) => {
      return (<>
        {/* <CustomizedProgressBars progress={cellValues.row.percentual} /> */}
          <LinearProgressWithLabel value={cellValues.row.percentual}/>
        </>);
    }
  },
  { field: 'prazo', headerName: "Prazo", width: 250 },
  { field: 'unidadeResponsavel', headerName: "Unidade Responsavel", width: 200 },
  { field: 'unidadeCoResponsavel', headerName: "Unidade Co-Responsavel", width: 250 }
];


export const apiGoal = axios.create({
  baseURL: 'https://docs.google.com/spreadsheets/d/e/2PACX-1vStX5cfx1d7sfdXK-GBpSUzFJvCM2hdJgT76XqWcgHRBqYxh5-oSKBNGbuITzGy52J2SLfq_s4DpsNH/pub?gid=0&single=true&output=tsv'
}
);
export const apiActions = axios.create({
  baseURL: 'https://docs.google.com/spreadsheets/d/e/2PACX-1vStX5cfx1d7sfdXK-GBpSUzFJvCM2hdJgT76XqWcgHRBqYxh5-oSKBNGbuITzGy52J2SLfq_s4DpsNH/pub?gid=589576948&single=true&output=tsv'
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
