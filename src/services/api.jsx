import axios from "axios";
import LinearProgressWithLabel from "../components/LinearProgressWithLabel";


export const columns = [
  { field: 'id', headerName: "ID", width: 100 },
  { field: 'unidadeResponsavel', headerName: "Unidade Responsável", width: 200 },
  { field: 'classificacaoObjetivo', headerName: "Classificação do Objetivo", width: 200 },
  { field: 'objetivo', headerName: "objetivo", width: 200 },
  { field: 'descricaoMetaTotal', headerName: "Descrição da Metal Total", width: 250  },
  { field: 'categoriaIndicador', headerName: "Categoria do Indicador", width: 250  },
  { field: 'meta2023', headerName: "Meta 2023", width: 250 },
  { field: 'resultadoAlcancado2023', headerName: "Resultado Alcançado 2023", width: 250 },
  { field: 'percentualAlcancado2023', headerName: "Alcançado 2023(%)", width: 250 },
  { field: 'metaGeral', headerName: "Meta Geral", width: 100 },
  {
    field: 'percentualGeralAlcancado', headerName: "Percentual Geral Alcançado", width: 250,
    renderCell: (cellValues) => {
      const numericValueStr = cellValues?.row?.percentualGeralAlcancado.replace(",", ".");
      if(isNaN(numericValueStr) || numericValueStr  === undefined || numericValueStr  === "") {
        return (<>-</>);
      }else {
        return (<>
          {<LinearProgressWithLabel value={parseFloat(numericValueStr)}/>}
        </>);
      }

    }
  },
  { field: 'justificativaNaoAlcanceMeta', headerName: "Justificativa do Não Alcance da Meta", width: 250 },
  { field: 'categoriaJustificativa', headerName: "Categoria/Justificativa", width: 250 }
];


export const apiGoal = axios.create({
  baseURL: 'https://docs.google.com/spreadsheets/d/e/2PACX-1vT2um-faGTupqjYkndRqp21VvatzpgTEHuxA71BO98TM0Mlm-A3NSim9JfNEZOr6MVkQlTV79X5l7WY/pub?gid=528168980&single=true&output=tsv'
}
);
export const apiActions = axios.create({
  baseURL: 'https://docs.google.com/spreadsheets/d/e/2PACX-1vT2um-faGTupqjYkndRqp21VvatzpgTEHuxA71BO98TM0Mlm-A3NSim9JfNEZOr6MVkQlTV79X5l7WY/pub?gid=589576948&single=true&output=tsv'
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

function tsvToJSON(tsv) {
  const lines = tsv.split('\r\n');
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
