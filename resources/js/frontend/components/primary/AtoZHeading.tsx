import { FC, HTMLAttributes } from "react";

export const AtoZHeading: FC<HTMLAttributes<HTMLHeadingElement>> = ({
    children,
    className = "",
    ...props
}) => (
    <h1
        className={`lg:text-5xl text-3xl text-white font-semibold ${className}`}
        {...props}
    >{children}</h1>
)