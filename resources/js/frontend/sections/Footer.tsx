import { FC } from "react"
import { FooterItem } from "../components"
import { LinkType } from "../data/models"
import { FOOTER_DEMO, NAVIGATION_DEMO } from "../data/navigation"
import { PestLogo2 } from "../static/PestLogo2"

interface FooterProps {
    items: LinkType[]
}

export const Footer: FC<FooterProps> = ({
    items = FOOTER_DEMO
}) => {
    return (
        <footer className=''>
            <PestLogo2 className='h-12 w-auto mb-12 hidden lg:block' />
            <div className='grid gap-y-2 w-full grid-cols-2 gap-10 lg:grid-cols-4 lg:gap-x-8'>
                {items && items.map((child, index) => (
                    <a key={index} href={child.link}>
                        <FooterItem>
                            {child.item}
                        </FooterItem>
                    </a>
                ))}
            </div>
        </footer>
    )
}