import React, { useEffect, useState } from "react";
import { Typography } from "@mui/material";
import Box from '@mui/material/Box';
import { DataGrid, ptBR } from '@mui/x-data-grid';
import { Modal } from "@mui/material";
import { fetchData } from "../../services/api";
import { Link } from "react-router-dom";
import Divider from '@mui/material/Divider';
import MenuList from '@mui/material/MenuList';
import MenuItem from '@mui/material/MenuItem';
import ListItemText from '@mui/material/ListItemText';
import ListItemIcon from '@mui/material/ListItemIcon';
import { Search } from "@material-ui/icons";

const columns = [
  { field: 'id', headerName: "Nº", width: 25 },
  { field: 'classificacaoObjetivo', headerName: "Classificação do Objetivo", width: 200 },
  { field: 'objetivo', headerName: "Objetivo", width: 200 },
  { field: 'classificacaoIndicador', headerName: "Classificação do Indicador", width: 250 },
  { field: 'categoriaIndicador', headerName: "Categoria do Indicador" },
  { field: 'tipoIndicador', headerName: "Tipo de Indicador" },
  { field: 'descricaoIndicador', headerName: "Descrição do Indicador", width: 300 },
  { field: 'percentual', headerName: "Percentual", width: 300 },
  { field: 'descricao', headerName: "Descrição da Meta", width: 300 },
  { field: 'prazo', headerName: "Prazo", width: 300 },
  { field: 'unidadeResponsavel', headerName: "Unidade Responsavel", width: 200 },
  { field: 'unidadeCoResponsavel', headerName: "Unidade Co-Responsavel", width: 300 }
];


const style = {
  position: 'absolute',
  top: '50%',
  left: '50%',
  transform: 'translate(-50%, -50%)',
  width: 400,
  bgcolor: 'background.paper',
  border: '2px solid #000',
  boxShadow: 24,
  p: 4,
};


export default function GridPanel() {
  const [goals, setGoals] = useState([]);
  const [open, setOpen] = useState(false);
  const [selectedGoal, setSelectedGoal] = useState(null);

  const handleOpen = (params) => {
    setSelectedGoal(params?.row);
    setOpen(true);
  };
  const handleClose = () => setOpen(false);

  useEffect(() => {
    fetchData(setGoals);
  }, []);




  return (
    <Box sx={{ height: 520, width: '100%' }}>
      <Modal
        open={open}
        onClose={handleClose}
        aria-labelledby="modal-modal-title"
        aria-describedby="modal-modal-description"
      >
        <Box sx={style}>

          <Typography id="modal-modal-title" variant="h6" component="h2">
            Meta Institucional Nº {selectedGoal?.id}
          </Typography>


          <Typography id="modal-modal-description" sx={{ mt: 2 }}>
            {selectedGoal?.descricao}
          </Typography>
          <MenuList>

            <Divider />
            <Link to={`/meta/${selectedGoal?.id}`}>
              <MenuItem>
                <ListItemIcon>
                  <Search fontSize="small" />
                </ListItemIcon>
                <ListItemText>Ver Detalhes</ListItemText>
              </MenuItem>
            </Link>
          </MenuList>
          

        </Box>
      </Modal>
      <DataGrid
        rows={goals}
        columns={columns}
        loading={goals.length === 0}
        rowHeight={40}
        localeText={ptBR.components.MuiDataGrid.defaultProps.localeText}
        onCellClick={handleOpen}
      />
    </Box>
  );
}
