import React, { useEffect, useState } from "react";
import Box from '@mui/material/Box';
import { DataGrid, ptBR } from '@mui/x-data-grid';



const columns = [
  {  field: 'id', headerName: "Nº", width: 25},
  {  field: 'classificacaoObjeto', headerName: "Classificação do Objeto", width: 200},
  {  field: 'objetivo', headerName: "Objetivo", width: 200}, 
  {  field: 'classificacaoIndicador', headerName: "Classificação do Indicador", width: 250}, 
  {  field: 'categoriaIndicador', headerName: "Categoria do Indicador"},
  {  field: 'tipo', headerName: "Tipo de Indicador"}, 
  {  field: 'descricao', headerName: "Descrição", width: 300}, 
  {  field: 'percentual', headerName: "Percentual", width: 300}, 
  {  field: 'descricaoMeta', headerName: "Descrição da Meta", width: 300}, 
  {  field: 'prazo', headerName: "Prazo", width: 300}, 
  {  field: 'unidadeResponsavel', headerName: "Unidade Responsavel", width: 300}, 
  {  field: 'unidadeCoResponsavel', headerName: "Unidade Co-Responsavel", width: 300}
];


export default function GridPanel() {
  const [goals, setGoals] = useState([]);
  
  const fetchGoals = async () => {
    try {
      const res = await fetch('https://sheetdb.io/api/v1/bj9pvb123v2kw');
      const data = await res.json();
      setGoals(data);
    } catch(error) {

    }
  }
  useEffect(() => {
    fetchGoals()
  }, []);



  return (
    <Box sx={{ height: 520, width: '100%' }}>
      <DataGrid
        rows={goals}
        columns = {columns}
        loading={goals.length === 0}
        rowHeight={40}
        localeText={ptBR.components.MuiDataGrid.defaultProps.localeText}
      />
    </Box>
  );
}
