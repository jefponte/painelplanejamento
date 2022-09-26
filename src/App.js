import Footer from "./components/Footer";
import Header from "./components/Header";
import Router from "./router/Router";
import { createTheme, ThemeProvider } from '@mui/material/styles';
import { CssBaseline } from '@mui/material';
import { ptBR } from '@mui/material/locale';


function App() {
  const theme = createTheme({
    status: {
      danger: '#e53e3e',
    },
    palette: {
      background: {
        default: '#FFF',
        paper: '#F5F6F9',
      },
      primary: {
        main: '#3b0304',
        darker: '#3b0304',

      },
      neutral: {
        main: '#64748B',
        contrastText: '#fff',
      },
    },
  }, ptBR);

  return (
    <ThemeProvider theme={theme}>
      <CssBaseline />
      <Header />
      <Router />
      <Footer />
    </ThemeProvider>
  );
}

export default App;
