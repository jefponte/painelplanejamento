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
} from "@material-ui/core";
import ExpandMoreIcon from "@mui/icons-material/ExpandMore";

export default function CardActions(props) {
  const acoes = props.acoes || [];

  return (
    <Accordion>
      <AccordionSummary
        expandIcon={<ExpandMoreIcon />}
        aria-controls="panel1a-content"
        id="panel1a-header"
      >
        <Typography>Ações</Typography>
      </AccordionSummary>
      <AccordionDetails>
        <List sx={{ width: '100%', maxWidth: 360, bgcolor: 'background.paper' }}>
          {acoes.map((acao) => {
            return (
              <React.Fragment key={acao.id}>
                <ListItem alignItems="flex-start">
                  <ListItemText
                    primary={acao?.acao}
                    secondary={
                      <React.Fragment>
                        <Typography
                          sx={{ display: 'inline' }}
                          component="span"
                          variant="body2"
                          color="text.primary"
                        >
                          Nivel: {acao?.nivel} 
                        </Typography><br/>
                        <Typography
                          sx={{ display: 'inline' }}
                          component="span"
                          variant="body2"
                          color="text.primary"
                        >
                            Recursos: {acao?.recursosAcao}
                        </Typography>
                        <br/>
                        <Typography
                          sx={{ display: 'inline' }}
                          component="span"
                          variant="body2"
                          color="text.primary"
                        >
                            Unidade Responsável: {acao?.unidadeResponsavel}
                        </Typography>

                      </React.Fragment>
                    }
                  />
                </ListItem>
                <Divider />
              </React.Fragment>
            );
          })}



        </List>
      </AccordionDetails>
    </Accordion>



  );
}