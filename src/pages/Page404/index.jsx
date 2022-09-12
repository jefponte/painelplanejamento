import { Container } from "@material-ui/core";
import { Typography } from "@mui/material";
import React from "react";
import imagem from "../../assets/img/404.png";
import styled from 'styled-components';

const Image404 = styled.img`
  margin-top: 5em;
  width: 100%;
`


const Page404 = () => {
  return (
    <Container maxWidth="sm">
      <Image404 src={imagem} alt="nao encontrada" />
      <Typography
        component="h1"
        variant="h4"
        align="center"
        color="textPrimary"
        gutterBottom
      >
        Página não encontrada
      </Typography>
    </Container>
  );
};
export default Page404;