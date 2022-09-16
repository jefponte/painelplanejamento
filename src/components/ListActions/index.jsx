import * as React from 'react';
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import Divider from '@mui/material/Divider';
import ListItemText from '@mui/material/ListItemText';
import Typography from '@mui/material/Typography';

export default function ListActions(props) {
  const acoes = props.acoes || [];

  return (
    <List sx={{ width: '100%', maxWidth: 360, bgcolor: 'background.paper' }}>
      {acoes.map((acao) => {
        return (
          <React.Fragment key={acao.id}>
            <ListItem alignItems="flex-start">
              <ListItemText
                primary={"Ação: " + acao.id}
                secondary={
                  <React.Fragment>
                    <Typography
                      sx={{ display: 'inline' }}
                      component="span"
                      variant="body2"
                      color="text.primary"
                    >
                      {acao.acao}
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
  );
}