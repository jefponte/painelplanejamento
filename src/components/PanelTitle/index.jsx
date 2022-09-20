import { Grid, Typography } from "@mui/material";
import React from "react";
import imagem from "../../assets/img/logo-proplan.png";
import CardMedia from '@mui/material/CardMedia';

export default function PanelTitle() {
    return (<>
    <br />
        <Grid container spacing={2}>
            <Grid item xs={12} md={9}>
                <Typography component="div" variant="h5">
                    Painel de Acompanhamento de Metas e Ações
                </Typography>
                <Typography variant="subtitle1" color="text.secondary" component="div">
                    Este painel possui a lista de metas institucionais e as ações a serem tomadas para realizar tais ações.
                </Typography>
            </Grid>
            <Grid item  xs={12} md={3}>
                <CardMedia
                    component="img"
                    sx={{ width: 250 }}
                    image={imagem}
                    alt="Logo Proplan"
                />
            </Grid>
        </Grid>


        <br />
    </>);
}