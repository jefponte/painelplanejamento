import React, { useEffect, useState } from "react";
import Box from '@mui/material/Box';
import { DataGrid, ptBR } from '@mui/x-data-grid';
import { useDemoData } from '@mui/x-data-grid-generator';
import {
  getData
} from "../../services/api";


export default function GridPanel() {
  const { data } = useDemoData({
    dataSet: 'Commodity',
    rowLength: 100000,
    editable: false,
  });
  const [dataContent, setDataContent] = useState({});
  useEffect(() => {
    getData(setDataContent);
  }, []);

  
  console.log(data);
  console.log(dataContent);
  return (
    <Box sx={{ height: 520, width: '100%' }}>
      <DataGrid
        {...data}
        loading={data.rows.length === 0}
        rowHeight={40}
         localeText={ptBR.components.MuiDataGrid.defaultProps.localeText}
      />
    </Box>
  );
}
