import { AppBar, Toolbar } from "@mui/material";
import Image from "../../assets/img/bg-topo.png";
import LogoUNILAB from "../../assets/img/logo-unilab.png";
import styled from "styled-components";

const ImageLogo = styled(({ color, ...otherProps }) => <img alt="Logo UNILAB" src={LogoUNILAB} {...otherProps} />)`
  width: 300px;
  padding: 30px;
`;

const styles = {
  paperContainer: {
    backgroundImage: `url(${Image})`,
  },
};

const Header = () => {
  return (
    <AppBar position="relative" style={styles.paperContainer}>
      <Toolbar>
        <ImageLogo/>
      </Toolbar>
    </AppBar>
  );
};
export default Header;