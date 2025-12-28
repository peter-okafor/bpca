import React, { AnchorHTMLAttributes } from 'react';

export const Back: React.FC<AnchorHTMLAttributes<HTMLAnchorElement>> = ({
  ...props
}) => {
  return (
    <a className={'align-middle text-center text-black text-xs font-semibold'} {...props}> &#60; &nbsp; Back</a>
  )
}