import * as React from 'react';
import Box from '@mui/material/Box';
import Card from '@mui/material/Card';
import CardContent from '@mui/material/CardContent';
import Typography from '@mui/material/Typography';
import { Grid } from '@mui/material';
import CardActions from '../CardActions';



export default function CardGoal(props) {
  const goal = props.goal || null;
  return (
    <Box sx={{ minWidth: 275 }}>
      <br/>
      <Grid container spacing={4}>
        <Grid item xl={4} lg={4} md={4} sm={12} xs={12}>
          <Card>
            <CardContent>
              <Typography variant="h5" component="div">
                Meta institucional: Nº{goal?.id}
              </Typography>
              <Typography sx={{ mb: 1.5 }} color="text.secondary">
                {goal?.descricaoMeta}
              </Typography>
              <Typography sx={{ mb: 1.5 }} color="text.secondary">
               Prazo: {goal?.prazo}
              </Typography>
              <Typography sx={{ mb: 1.5 }} color="text.secondary">
               Unidade Responsável: {goal?.unidadeResponsavel}
              </Typography>
              <Typography sx={{ mb: 1.5 }} color="text.secondary">
               Unidade co-responsável: {goal?.unidadeCoResponsavel}
              </Typography>
            </CardContent>
          </Card>

          <br/><CardActions acoes={goal?.acoes} />
        </Grid>


        <Grid item xl={4} lg={4} md={4} sm={12} xs={12}>
          <Card>
            <CardContent>
              <Typography variant="h5" component="div">
                Objetivo
              </Typography>
              <Typography sx={{ mb: 1.5 }} color="text.secondary">
                {goal?.objetivo}
              </Typography>
              <Typography sx={{ mb: 1.5 }} color="text.secondary">
               Classificação: {goal?.classificacaoObjetivo}
              </Typography>
              
            </CardContent>
          </Card>
        </Grid>

        <Grid item xl={4} lg={4} md={4} sm={12} xs={12}>
          <Card>
            <CardContent>
              <Typography variant="h5" component="div">
                Indicador
              </Typography>
              <Typography sx={{ mb: 1.5 }} color="text.secondary">
                Classificação:  {goal?.classificacaoIndicador}
              </Typography>
              <Typography sx={{ mb: 1.5 }} color="text.secondary">
               Categoria: {goal?.categoriaIndicador}
              </Typography>
              <Typography sx={{ mb: 1.5 }} color="text.secondary">
               Tipo: {goal?.tipo}
              </Typography>
              <Typography sx={{ mb: 1.5 }} color="text.secondary">
                Descricao: {goal?.descricao}
              </Typography>
              <Typography sx={{ mb: 1.5 }} color="text.secondary">
                Percentual: {goal?.percentual}
              </Typography>
            </CardContent>
          </Card>
        </Grid>

       



      </Grid>


    </Box>
  );
}
