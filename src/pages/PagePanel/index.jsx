import { Container, Typography } from "@mui/material";
import React from "react";
import GridPanel from "../GridPanel";
import imagem from "../../assets/img/logo-proplan.png";
import Box from '@mui/material/Box';
import Card from '@mui/material/Card';
import CardContent from '@mui/material/CardContent';
import CardMedia from '@mui/material/CardMedia';


function PagePanel() {



  return (

    <Container maxWidth={"lg"}>
      <br/>
      <Card sx={{ display: 'flex' }}>
        <Box sx={{ flexGrow: 1 }}>
          <CardContent sx={{ flex: '1 0 auto' }}>
            <Typography component="div" variant="h5">
              Painel de Acompanhamento de Metas e Ações
            </Typography>
            <Typography variant="subtitle1" color="text.secondary" component="div">
              Este painel possui a lista de metas institucionais e as ações a serem tomadas para realizar tais ações.  
            </Typography>
          </CardContent>

        </Box>
        <Box >
          <CardMedia
            component="img"
            sx={{ width: 250 }}
            image={imagem}
            alt="Logo Proplan"
          />
        </Box>
      </Card>

      <GridPanel />
    </Container>
  );
}

export default PagePanel;
