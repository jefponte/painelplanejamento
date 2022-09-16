import * as React from 'react';
import Box from '@mui/material/Box';
import Card from '@mui/material/Card';
import CardContent from '@mui/material/CardContent';
import Typography from '@mui/material/Typography';


export default function CardGoal(props) {
  const goal = props.goal || null;
  return (
    <Box sx={{ minWidth: 275 }}>
      <Card variant="outlined">

        <React.Fragment>
          <CardContent>
            <Typography sx={{ fontSize: 14 }} color="text.secondary" gutterBottom>
              {goal?.objetivo}
            </Typography>
            <Typography variant="h5" component="div">
              {goal?.descricao}
            </Typography>
            <Typography sx={{ mb: 1.5 }} color="text.secondary">
              {goal?.classificacaoObjeto}
            </Typography>

            <Typography sx={{ mb: 1.5 }} color="text.secondary">
              {goal?.percentual}
            </Typography>
            <Typography sx={{ mb: 1.5 }} color="text.secondary">
              {goal?.classificacaoObjeto}
            </Typography>
            
            <Typography sx={{ mb: 1.5 }} color="text.secondary">
              {goal?.unidadeResponsavel}
            </Typography>
            <Typography sx={{ mb: 1.5 }} color="text.secondary">
              {goal?.prazo}
            </Typography>
          </CardContent>
          
        </React.Fragment>
      </Card>
    </Box>
  );
}
