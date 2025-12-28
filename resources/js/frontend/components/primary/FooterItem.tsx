import { FC } from "react"

interface FooterItemProps {
    children: string;
}

export const FooterItem: FC<FooterItemProps> = ({
    children
}) => {
    return (
        <p className='text-white opacity-100 mx-2 my-1'>{children}</p>
    )
}