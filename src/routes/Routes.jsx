import { BrowserRouter as Router, Route, Switch } from "react-router-dom";
import PagePanel from "../pages/PagePanel";

function Routes() {
  return (
    <Router>
      <Switch>
        <Route>
          <PagePanel />
        </Route>
      </Switch>
    </Router>
  );
}

export default Routes;