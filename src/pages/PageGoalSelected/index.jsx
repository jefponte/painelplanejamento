import { Container } from "@mui/material";
import React from "react";
import { useParams } from "react-router";
import { useState } from "react";
import { useEffect } from "react";
import { fetchSelected } from "../../services/api";
import CardGoal from "../../components/CardGoal";
import PanelTitle from "../../components/PanelTitle";


function PageGoalSelected() {
  const { id } = useParams();
  const [selectedGoal, setSelectedGoal] = useState(null);


  useEffect(() => {
    fetchSelected(setSelectedGoal, id);
  }, [id]);
  return (
    <Container maxWidth={"lg"}>
      <PanelTitle/>
      <CardGoal goal={selectedGoal}/>
    </Container>
  );
}

export default PageGoalSelected;
