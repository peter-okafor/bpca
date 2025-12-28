import React from "react";
import { Link } from '@inertiajs/inertia-react';
import logoImg from "../../images/logo.png";
import logoLightImg from "../../images/logo-light.png";
import { PestLogo } from "@/frontend/static/PestLogo";

export interface LogoProps {
  img?: string;
  imgLight?: string;
}

const Logo: React.FC<LogoProps> = ({
  img = logoImg,
  imgLight = logoLightImg,
}) => {
  return (
    <Link href="/" className="ttnc-logo inline-block text-primary-6000">
      {/* THIS USE FOR MY MULTI DEMO */}
      {/* IF YOU ARE MY CLIENT. PLESE DELETE THIS CODE AND YOU YOUR IMAGE PNG BY BELLOW CODE */}
      <PestLogo className="w-auto h-8" />
    </Link>
  );
};

export default Logo;
