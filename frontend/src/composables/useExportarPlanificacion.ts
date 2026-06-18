import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'
import {
  Document, Packer, Paragraph, Table, TableRow, TableCell,
  TextRun, WidthType, HeadingLevel, AlignmentType, ShadingType,
} from 'docx'
import { saveAs } from 'file-saver'
import type { DatosAnual, DatosDiaria } from '@/types/planificacion'

// ─── Color corporativo ────────────────────────────────────────────────────────
const COLOR_HEADER = '1e3a5f'
const COLOR_SUBHEADER = '2c4f7c'

// ─── Helpers ──────────────────────────────────────────────────────────────────

function celdaHeader(text: string, cols = 1, color = COLOR_HEADER): TableCell {
  return new TableCell({
    columnSpan: cols,
    shading: { type: ShadingType.SOLID, color, fill: color },
    children: [new Paragraph({
      alignment: AlignmentType.CENTER,
      children: [new TextRun({ text, bold: true, color: 'FFFFFF', size: 20 })],
    })],
  })
}

function celdaLabel(text: string): TableCell {
  return new TableCell({
    shading: { type: ShadingType.SOLID, color: COLOR_HEADER, fill: COLOR_HEADER },
    children: [new Paragraph({
      children: [new TextRun({ text, bold: true, color: 'FFFFFF', size: 18 })],
    })],
    width: { size: 20, type: WidthType.PERCENTAGE },
  })
}

function celdaTexto(text: string, cols = 1, ancho?: number): TableCell {
  return new TableCell({
    columnSpan: cols,
    children: [new Paragraph({
      children: [new TextRun({ text: text || '', size: 18 })],
    })],
    ...(ancho ? { width: { size: ancho, type: WidthType.PERCENTAGE } } : {}),
  })
}

// ─── Exportar PDF ─────────────────────────────────────────────────────────────

export function useExportarPlanificacion() {
  async function exportarPDF(elementId: string, nombreArchivo: string) {
    const elemento = document.getElementById(elementId)
    if (!elemento) return

    const canvas = await html2canvas(elemento, { scale: 2 })
    const imgData = canvas.toDataURL('image/png')

    const pdf = new jsPDF('p', 'mm', 'a4')
    const pageWidth = pdf.internal.pageSize.getWidth()
    const pageHeight = pdf.internal.pageSize.getHeight()

    const imgWidth = pageWidth
    const imgHeight = (canvas.height * imgWidth) / canvas.width

    let heightLeft = imgHeight
    let position = 0

    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight)
    heightLeft -= pageHeight

    while (heightLeft > 0) {
      position = heightLeft - imgHeight
      pdf.addPage()
      pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight)
      heightLeft -= pageHeight
    }

    pdf.save(`${nombreArchivo}.pdf`)
  }

  // ─── Exportar Word (planificación diaria) ─────────────────────────────────

  async function exportarWordDiaria(datos: DatosDiaria) {
    const filas = [
      ['Fecha estimada', datos.fecha_estimada, 'Fecha desarrollada', datos.fecha_desarrollada],
      ['Fecha de presentación', datos.fecha_presentacion, '', ''],
      ['Contenidos específicos', datos.contenidos_especificos, '', ''],
      ['Actividades', datos.actividades, '', ''],
      ['Tareas', datos.tareas, '', ''],
    ]

    const tabla = new Table({
      width: { size: 100, type: WidthType.PERCENTAGE },
      rows: filas.map(fila =>
        new TableRow({
          children: fila.map((celda, i) =>
            new TableCell({
              children: [new Paragraph({
                children: [new TextRun({ text: celda, bold: i % 2 === 0 })],
              })],
              width: { size: 25, type: WidthType.PERCENTAGE },
            })
          ),
        })
      ),
    })

    const doc = new Document({
      sections: [{
        children: [
          new Paragraph({ text: 'Planificación Diaria', heading: HeadingLevel.HEADING_1 }),
          tabla,
        ],
      }],
    })

    const buffer = await Packer.toBlob(doc)
    saveAs(buffer, 'planificacion_diaria.docx')
  }

  // ─── Exportar Word (planificación anual) ──────────────────────────────────

  async function exportarWordAnual(datos: DatosAnual) {
    const children: (Paragraph | Table)[] = []

    children.push(new Paragraph({
      text: 'Planificación Anual',
      heading: HeadingLevel.HEADING_1,
      alignment: AlignmentType.CENTER,
    }))

    children.push(new Table({
      width: { size: 100, type: WidthType.PERCENTAGE },
      rows: [
        new TableRow({ children: [
          celdaLabel('Grado'), celdaTexto(datos.grado, 1, 30),
          celdaLabel('Ciclo'), celdaTexto(datos.ciclo, 1, 30),
        ]}),
        new TableRow({ children: [
          celdaLabel('Año'), celdaTexto(datos.anio, 1, 30),
          celdaLabel('Fecha presentación'), celdaTexto(datos.fecha_presentacion, 1, 30),
        ]}),
        new TableRow({ children: [celdaLabel('Diagnóstico'), celdaTexto(datos.diagnostico, 3)] }),
        new TableRow({ children: [celdaLabel('Bibliografía'), celdaTexto(datos.bibliografia, 3)] }),
      ],
    }))

    children.push(new Paragraph({ text: '' }))

    for (const materia of datos.materias) {
      const filasMateria: TableRow[] = [
        new TableRow({ children: [celdaHeader(materia.nombre.toUpperCase(), 5)] }),
        new TableRow({ children: [
          celdaHeader('Mes', 1, COLOR_SUBHEADER),
          celdaHeader('Eje', 1, COLOR_SUBHEADER),
          celdaHeader('Saberes a desarrollar', 1, COLOR_SUBHEADER),
          celdaHeader('Consideraciones didácticas', 1, COLOR_SUBHEADER),
          celdaHeader('Aprendizajes esperados', 1, COLOR_SUBHEADER),
        ]}),
      ]

      for (const periodo of materia.periodos) {
        filasMateria.push(new TableRow({ children: [
          celdaTexto(periodo.nombre),
          celdaTexto(periodo.eje),
          celdaTexto(periodo.saberes),
          celdaTexto(periodo.consideraciones_didacticas),
          celdaTexto(periodo.aprendizajes_esperados),
        ]}))
      }

      filasMateria.push(
        new TableRow({ children: [
          celdaHeader('Criterios de evaluación y acreditación', 3, COLOR_SUBHEADER),
          celdaHeader('Instrumentos de evaluación', 2, COLOR_SUBHEADER),
        ]}),
        new TableRow({ children: [
          celdaTexto(materia.criterios_evaluacion, 3),
          celdaTexto(materia.instrumentos_evaluacion, 2),
        ]}),
      )

      children.push(new Table({
        width: { size: 100, type: WidthType.PERCENTAGE },
        rows: filasMateria,
      }))

      children.push(new Paragraph({ text: '' }))
    }

    if (datos.saberes_transversales) {
      children.push(new Table({
        width: { size: 100, type: WidthType.PERCENTAGE },
        rows: [
          new TableRow({ children: [celdaHeader('Saberes Transversales - Ética y Ciudadana', 1)] }),
          new TableRow({ children: [celdaTexto(datos.saberes_transversales)] }),
        ],
      }))
    }

    const doc = new Document({ sections: [{ children }] })
    const buffer = await Packer.toBlob(doc)
    saveAs(buffer, 'planificacion_anual.docx')
  }

  return {
    exportarPDF,
    exportarWordDiaria,
    exportarWordAnual,
  }
}