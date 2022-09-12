import { Container, Typography } from "@mui/material";
import React from "react";
import GridPanel from "../GridPanel";
import imagem from "../../assets/img/logo-proplan.png";

function PagePanel() {



  return (
    <Container maxWidth={"lg"}>

      
      <Typography variant="h5" align="center" color="textSecondary" paragraph>
        <img src={imagem} width={250} alt="nao encontrada" />
      </Typography>
      <Typography
        component="h1"
        variant="h4"
        align="center"
        color="textPrimary"
        gutterBottom
      >
        Painel de Acompanhamento
      </Typography>
      <GridPanel/>
    </Container>
  );
}

export default PagePanel;
