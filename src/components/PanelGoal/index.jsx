import * as React from 'react';
import Box from '@mui/material/Box';
import Card from '@mui/material/Card';
import CardContent from '@mui/material/CardContent';
import Typography from '@mui/material/Typography';
import { Grid, Link } from '@mui/material';
import CardActions from '../CardActions';
import CardLoad from '../CardLoad';
import LinearProgressWithLabel from '../LinearProgressWithLabel';





export default function PanelGoal(props) {
  const goal = props.goal || null;
  if (goal === null) {
    return (
      <>
        <CardLoad/>
      </>
    );
  }
  const parseNumber =  (strValue) => {
    if(strValue === null || strValue === undefined || strValue === "") {
      return 0;
    }
    const numericValueStr = strValue.replace(",", ".");
    return numericValueStr;

  }
  return (
    <Box sx={{ minWidth: 275 }}>
      <br />
      <Grid container spacing={4}>
        <Grid item xl={4} lg={4} md={4} sm={12} xs={12}>
          <Card>
            <CardContent>
              <Typography variant="h5" component="div">
                ID: Nº{goal?.id}
              </Typography>

              <Typography sx={{ mb: 1.5 }} color="text.secondary">
                Unidade Responsável: {goal?.unidadeResponsavel}
              </Typography>

              <Typography sx={{ mb: 1.5 }} color="text.secondary">
                Objetivo: {goal?.objetivo}
              </Typography>

              <Link href="/" underline="hover">
                Retornar ao Painel
              </Link>

            </CardContent>
          </Card>

          <br /><CardActions acoes={goal?.acoes} />
        </Grid>


        <Grid item xl={4} lg={4} md={4} sm={12} xs={12}>
          <Card>
            <CardContent>
              <Typography variant="h5" component="div">
                Descrição da Meta
              </Typography>
            <Typography sx={{ mb: 1.5 }} color="text.secondary">
                {goal?.descricaoMetaTotal}
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
                Resultados Esperado: {goal?.meta2023}
              </Typography>
              <Typography sx={{ mb: 1.5 }} color="text.secondary">
                Resultados Alcançados: {goal?.percentualAlcancado2023}
              </Typography>
              <Typography sx={{ mb: 1.5 }} color="text.secondary">
                Percentual Geral Alcançado
              </Typography>
              <LinearProgressWithLabel value={parseNumber(goal?.percentualGeralAlcancado)} />
              <Typography sx={{ mb: 1.5 }} color="text.secondary">
                Justificativa para o não alcance: {goal?.justificativaNaoAlcanceMeta}
              </Typography>
            </CardContent>
          </Card>
        </Grid>





      </Grid>


    </Box>
  );
}
