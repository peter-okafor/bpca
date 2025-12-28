import { FC, HTMLAttributes } from "react";

export const AtoZDescription: FC<HTMLAttributes<HTMLParagraphElement>> = ({
    className,
    children,
    ...props
}) => (
    <p className={`text-base text-white ${className}`} {...props}>{children}</p>
)