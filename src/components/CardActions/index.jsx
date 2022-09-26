import * as React from 'react';
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import Divider from '@mui/material/Divider';
import ListItemText from '@mui/material/ListItemText';
import {
  Accordion,
  AccordionSummary,
  AccordionDetails,
  Typography,
} from "@mui/material";
import ExpandMoreIcon from "@mui/icons-material/ExpandMore";
import Box from '@mui/material/Box';
import ListItemButton from '@mui/material/ListItemButton';
import { useState } from 'react';
import ModalAction from '../ModalAction';

export default function CardActions(props) {
  const acoes = props.acoes || [];
  const [actionSelected, setActionSelected] = useState(null);
  const [modalOpen, setModalOpen] = useState(false);
  if (acoes.length === 0) {
    return <></>;
  }
  const handleActionClick = (acao) => {
    setActionSelected(acao);
    setModalOpen(true);
  }
  const handleClose =  () => {
    setModalOpen(false);
  }
  return (
    <React.Fragment>
      <ModalAction handleClose={handleClose} action={actionSelected} open={modalOpen}/>
    <Accordion>
      <AccordionSummary
        expandIcon={<ExpandMoreIcon />}
        aria-controls="panel1a-content"
        id="panel1a-header"
      >
        <Typography>Ações</Typography>
      </AccordionSummary>
      <AccordionDetails>

        <Box sx={{ width: '100%', maxWidth: 360, bgcolor: 'background.paper' }}>

          <Divider />
          <nav aria-label="secondary mailbox folders">
            <List>
              {acoes.map((acao) => {
                return (
                  <ListItem disablePadding key={acao.id}>
                    <ListItemButton>
                      <ListItemText onClick={() => {
                        handleActionClick(acao)
                      }} primary={acao.acao} />
                    </ListItemButton>
                  </ListItem>
                );
              })}


            </List>
          </nav>
        </Box>

      </AccordionDetails>
    </Accordion>

    </React.Fragment>

  );
}