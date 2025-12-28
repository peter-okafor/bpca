import React, { AnchorHTMLAttributes } from 'react';

export const Next: React.FC<AnchorHTMLAttributes<HTMLAnchorElement>> = ({
  ...props
}) => {
  return (
    <a className={'align-middle text-center text-black text-xs font-semibold'} {...props}> Next &nbsp; &#62;</a>
  )
}