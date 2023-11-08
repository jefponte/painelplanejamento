import { Container } from "@mui/material";
import React from "react";
import GridPanel from "../GridPanel";
import Card from '@mui/material/Card';
import PanelTitle from "../../components/PanelTitle";


function PagePanel() {



  return (

    <Container maxWidth={"lg"}>
      <PanelTitle/>
      <Card variant="outlined">
        <GridPanel />
      </Card>
    </Container>
  );
}

export default PagePanel;
