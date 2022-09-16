import { BrowserRouter as Router, Route, Switch } from "react-router-dom";
import PageGoalSelected from "../pages/PageGoalSelected";
import PagePanel from "../pages/PagePanel";

function Routes() {
  return (
    <Router>
      <Switch>
        <Route exact path="/">
          <PagePanel />
        </Route>
        <Route path="/meta/:id">
          <PageGoalSelected />
        </Route>
        <Route>
          <PagePanel />
        </Route>
      </Switch>
    </Router>
  );
}

export default Routes;